<?php

namespace Movibe\BackendBundle\Controller;

use Movibe\BackendBundle\Entity\BoxOfficeDate;
use Movibe\BackendBundle\Form\BoxOfficeDateType;
use Movibe\BackendBundle\Form\BoxOfficeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Movibe\BackendBundle\Entity\BoxOffice;

/**
 * BoxOffice controller.
 *
 */
class BoxOfficeController extends AbstractController
{
    /**
     * Deletes a BoxOffice entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $boxOffice = $em->getRepository('MovibeBackendBundle:BoxOffice')->find($id);

        if (!$boxOffice) {
            throw $this->createNotFoundException("Le boxOffice indiqué n'a pas été trouvé.");
        }

        $em->remove($boxOffice);
        $em->flush();


        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(true);
        }
        else
        {
            $request->getSession()->getFlashbag()->add('message','Le boxOffice sélectionné a été supprimé');
            return $this->redirect($this->generateUrl('movibe_backend_boxOfficeDate_new'));
        }
    }
}
