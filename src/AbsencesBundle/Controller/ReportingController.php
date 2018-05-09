<?php
/**
 * Created by PhpStorm.
 * User: Haosh
 * Date: 20/04/2018
 * Time: 15:28
 */

namespace AbsencesBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SSRS\Report;


class ReportingController extends Controller
{
    /**
     * @Route("/reports", name="reports")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $ssrs = new Report("http://LAPTOP-48KMKF8K:8090/ReportService", array('username' => 'roche', 'password' => 'roche'));

        $lists = $ssrs->listChildren('/Absence');


        return $this->render('reports/index.html.twig', [
            'ssrs' => $ssrs
        ]);

    }
}