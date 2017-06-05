<?php

namespace ContactBundle\Controller;

use CommonBundle\Controller\AbstractBaseController;
use ContactBundle\Form\Model\ContactModel;
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
            $this->addFlash(
                'success',
                $this->getTranslator()->trans('contact.message.sent.success', [], 'messages')
            );
        }

        return $this->render(
            "ContactBundle:Contact:index.html.twig",
            [
                'form' => $form->createView()
            ]
        );
    }
}