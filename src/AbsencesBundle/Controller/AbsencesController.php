<?php

namespace AbsencesBundle\Controller;

use AbsencesBundle\Entity\Absence;
use AbsencesBundle\Form\AbsencesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class AbsencesController extends Controller
{
    /**
     * @Route("/absences", name="absences")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $absence = new Absence();

        $form = $this->createForm(AbsencesType::class, $absence);

        $form->handleRequest($request);

        return $this->render('absences/index.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/absences/addEvent", name="addEvent")
     * @Method({"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addEventAction(Request $request)
    {
            $absence = new Absence();
            $title = $request->request->get('title');
            $title = (string)$title;
            $startDate = $request->request->get('startTime');

            $startD = \DateTime::createFromFormat('d/m/Y', trim($startDate));


           // $startD = strtotime($startDate);

           // $startD = date('Y-m-d',$startD);




            $endDate = $request->request->get('endTime');


            $endD = \DateTime::createFromFormat('d/m/Y', trim($endDate));

            //$endD = strtotime($endDate);

            //$endD = date('Y-m-d',$endD);


            $allDay = $request->request->get('radioInline');
            $allDay = (int)$allDay;

            $uid= $this->getUser();
            $valide = 0;
            $delete = false;

            $absence->setTitle($title);
            $absence->setStartTime($startD);
            $absence->setEndTime($endD);
            $absence->setValide($valide);
            $absence->setDeleted($delete);
            $absence->setAllday($allDay);
            $absence->setUid($uid);

            $em = $this->getDoctrine()->getManager();
        outLog('$absence : ', $absence);
            $em->persist($absence);
            $em->flush();

            $this->addFlash(
                'notice',
                'Vous avez bien déposé votre congé, veuillez patienter la validation'
            );

            //return $this->redirectToRoute('absences');

        return new Response('ok');
    }


    /**
     * @Route("/absences/loadEvent", name="loadEvent", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function loadEventAction(Request $request) {

        //Load events


        $events = $this->getDoctrine()
            ->getManager()
            ->getRepository('AbsencesBundle:Absence')
            ->getAllAbsences();


        return new JsonResponse($events);

    }



}
