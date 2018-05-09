<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Member;
use AppBundle\Form\Type\MemberType;

class DashBoardController extends Controller
{


    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        
        return $this->render('dashboard/index.html.twig', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/profile", name="profile")
     */
    public function profileAction(Request $request)
    {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createForm(MemberType::class, $defaultData);

        
        // replace this example code with whatever you need
        return $this->render('menucontent/profile.html.twig', [
           'form' => $form->createView(),
        ]);
    }

    
}
