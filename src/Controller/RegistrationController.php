<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * This is Description of RegistrationController class
 *
 */
class RegistrationController extends Controller
{
    /**
     * Description:
     *
     * @Route("/register", name = "registration")
     *
     * @return Response
     *
     * @throws \LogicException
     *
     */
    public function registerAction()
    {
        $member = new User();

        $form = $this->createRegistrationForm($member);

        return $this->render('registration/register.html.twig', [
            'registration_form' => $form->createView()
        ]);
    }
    /**
     * Description:
     *
     * @Route("/register-form-submission", name="handle_registration_form_submission")
     * @Method("POST")
     *
     * @param Request $request
     *
     * @return RedirectResponse | Response
     *
     * @throws \LogicException
     *
     */
    public function handleFormSubmissionAction(Request $request)
    {
        $member = new User();

        $form = $this->createRegistrationForm($member);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('registration/register.html.twig', [
                'registration_form' => $form->createView()
            ]);
        }

        $password = $this
            ->get('security.password_encoder')
            ->encodePassword($member, $member->getPlainPassword());

        $member->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($member);
        $em->flush();

        $token = new UsernamePasswordToken(
            $member,
            $password,
            'main',
            $member->getRoles()
        );

        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        $this->addFlash('success', 'Your are now successfully registered!!!');

        return $this->redirectToRoute('home');
    }

    /**
     *
     * Description:
     *
     * @param $member
     *
     * @return Form
     *
     */
    private function createRegistrationForm($member)
    {
        return $this->createForm(UserType::class, $member, [
            'action' => $this->generateUrl('handle_registration_form_submission')
        ]);
    }
}