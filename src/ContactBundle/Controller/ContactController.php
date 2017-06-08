<?php

namespace ContactBundle\Controller;

use CommonBundle\Controller\AbstractBaseController;
use ContactBundle\Form\Model\ContactModel;
use ContactBundle\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 *
 * @package ContactBundle\Controller
 */
class ContactController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $contact = new ContactModel();

        $form = $this->createForm(
            ContactType::class,
            $contact,
            [
                'method' => 'POST',
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = new \Swift_Message();
            $message
                ->setTo('theusualdreamers+contact@gmail.com')
                ->setSubject('[CONTACT] ' . $contact->getSubject())
                ->setBody($this->renderView(
                    'ContactBundle:Contact:email.html.twig',
                    ['contact' => $contact]
                ))
                ->setContentType('text/html');

            $this->getMailer()->send($message);

            $this->addFlash(
                'success',
                $this->getTranslator()->trans('contact.message.sent.success', [], 'messages')
            );

            return $this->redirectToRoute('contact_contact_index');
        }

        return $this->render(
            'ContactBundle:Contact:index.html.twig',
            ['form' => $form->createView()]
        );
    }
}