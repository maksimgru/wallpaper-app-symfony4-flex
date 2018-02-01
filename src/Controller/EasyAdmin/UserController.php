<?php

namespace App\Controller\EasyAdmin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserController extends BaseAdminController
{
    /**
     * @param User $entity
     * @return RedirectResponse
     * @throws \LogicException
     */
    protected function prePersistEntity($entity)
    {
        return $this->saveEntity($entity);
    }

    /**
     * @param User $entity
     * @return RedirectResponse
     * @throws \LogicException
     */
    protected function preUpdateEntity($entity)
    {
        return $this->saveEntity($entity);
    }

    /**
     * @param User $entity
     * @return RedirectResponse
     * @throws \LogicException
     */
    private function saveEntity($entity)
    {
        $em = $this->getDoctrine()->getManager();

        $plainPassword = $entity->getId() ? trim($entity->getPlainPassword()) : $entity->getUsername();

        if ($plainPassword) {
            $password = $this
                ->get('security.password_encoder')
                ->encodePassword($entity, $plainPassword);
            $entity->setPassword($password);
        }

        $em->persist($entity);
        $em->flush();

        $this->addFlash('success', sprintf('User `%s` is saved!', $entity->getUsername()));

        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
        ]);
    }
}
