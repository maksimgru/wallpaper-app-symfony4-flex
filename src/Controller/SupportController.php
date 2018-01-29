<?php

namespace App\Controller;

use App\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SupportController extends Controller
{
    /**
     * Description:
     *
     * @Route("/contact", name="contact")
     *
     * @return Response
     *
     */
    public function indexAction()
    {
        $form = $form = $this->createContactForm();

        return $this->render('support/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }

    /**
     * Description:
     *
     * @Route("/contact-form-submission", name="handle_contact_form_submission")
     * @Method("POST")
     *
     * @param Request $request
     * @param ContainerInterface $container
     * @param TokenStorageInterface $tokenStorage
     * @param \Swift_Mailer $mailer
     *
     * @return RedirectResponse
     *
     * @throws \LogicException
     *
     */
    public function handleFormSubmissionAction(
        Request $request,
        ContainerInterface $container,
        TokenStorageInterface $tokenStorage,
        \Swift_Mailer $mailer
    ) {
        $form = $this->createContactForm();

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->redirectToRoute('contact');
        }

        $contactFormData = $form->getData();

        $adminEmail = $container->getParameter('admin_email');
        $currentUser = $tokenStorage->getToken()->getUser();
        $currentUserName = $currentUser->getUsername();
        $currentUserEmail = $contactFormData['from'];
        $currentUserMessage = $contactFormData['message'];
        $subject = 'From "' . $currentUserName . '" | Wallpaper Contact Form';

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom($currentUserEmail)
            ->setReplyTo($currentUserEmail)
            ->setTo($adminEmail)
            ->setBody(
                $this->renderView(
                    'support/email-template.html.twig',
                    [
                        'currentUserName' => $currentUserName,
                        'currentUserEmail' => $currentUserEmail,
                        'currentUserMessage' => $currentUserMessage,
                    ]
                ),
                'text/html'
            );

        $mailer->send($message);

        $this->addFlash('success', 'Your message was sent!!!');

        return $this->redirectToRoute('contact');
    }

    /**
     *
     * Description:
     *
     * @return Form
     *
     */
    private function createContactForm()
    {
        return $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl('handle_contact_form_submission'),
        ]);
    }
}
