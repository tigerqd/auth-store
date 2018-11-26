<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Controller\V1;

use Core\RestApiBundle\Form\UserRegisterType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractAuthController
{
    /**
     * @Route("register", name="register", methods={"POST"})
     * @throws \HttpRuntimeException
     */
    public function register(): JsonResponse
    {
        $request = $this->requestStack->getCurrentRequest();

        $this->denyAccessIfUserLoggedIn();
        $this->validateRequest($request);

        $form = $this->createForm(UserRegisterType::class);

        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userManager->create($form->getData());
            $this->dispatchUserLogin($user, $request);

            return $this->responder->send();
        }

        $this->handleWrongValidation($form);
    }
}
