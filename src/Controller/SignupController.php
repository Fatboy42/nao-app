<?php 

namespace App\Controller;

use App\Form\SignupType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SignupController extends Controller
{
	/**
	 * @Route("/signup")
	 */
	public function signup(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface)
	{
		$user = new User();
		$form = $this->createForm(SignupType::class, $user);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) 
		{
			$password = $userPasswordEncoderInterface->encodePassword($user, $user->getPassword());
			$user->setPassword($password);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('home');
		}

		return $this->render('signup.html.twig', array(
			'form' => $form->createView()
		));
		
	}
}

 ?>