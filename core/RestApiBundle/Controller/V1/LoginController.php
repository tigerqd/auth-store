<?php

declare(strict_types=1);

namespace Core\RestApiBundle\Controller\V1;

use Core\RestApiBundle\Exception\IncorrectUserNickNameException;
use Core\RestApiBundle\Form\UserLoginType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class LoginController extends AbstractAuthController
{
    /**
     * @Route("login", name="login", methods={"POST"})
     *
     * @throws \HttpRuntimeException
     * @throws AccessDeniedException
     */
    public function login(): JsonResponse
    {
        $request = $this->requestStack->getCurrentRequest();

        $this->denyAccessIfUserLoggedIn();
        $this->validateRequest($request);

        $form = $this->createForm(UserLoginType::class);

        $form->submit(
            $this->only(['nickname', 'password'])
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $userData = $form->getData();

            $user = $this->userManager->findOneByNickName($userData->getUsername());

            if (null === $user) {
                throw new IncorrectUserNickNameException('Incorrect user nickname!');
            }

            $this->dispatchUserLogin($user, $request);

            return $this->responder->send();
        }

        $this->handleWrongValidation($form);
    }

    private function only(array $keys): array
    {
        $result = [];
        $request = $this->requestStack->getCurrentRequest();

        if (null === $request) {
            return $result;
        }

        $data = $request->request->all();

        return array_intersect_key(
            $data,
            array_flip($keys)
        );
    }
}
