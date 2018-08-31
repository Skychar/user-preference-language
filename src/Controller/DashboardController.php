<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DashboardController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {


        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }


    /**
    * @route("/changeLocale", name="changeLocale")
    */
    public function changeLocale(Request $request)
    {
    	$form = $this->createFormBuilder(null)
    		->add('locale', ChoiceType::class, [
    			'choices' => [
    				'Français' 		=> 'fr_FR',
    				'L3arabiya'		=> 'ar_AR',
    				'English(US)'	=> 'en_US'
    			]
    		])
    		->add('save', SubmitType::class)
    		->getForm()
		;

		$form->handleRequest($request);

		if ($form->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			$locale = $form->getData()['locale'];
			$user = $this->getUser();
			$user->setLocale($locale);
			$em->persist($user);
			$em->flush();
		}

    	return $this->render('dashboard/locale.html.twig', [
    		'form'		=> $form->createView()
    	]);
    }

}
