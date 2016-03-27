<?php

namespace CMS\Controller;


use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\DatabaseException;
use Blog\Model\User;

/**
 * Class ProfileController
 * @package CMS\Controller
 */

class ProfileController extends Controller {

    /**
     * Serves for updating profile
     *
     * @route /profile
     * @return \Framework\Response\Response|\Framework\Response\ResponseRedirect
     */

    function updateAction() {

        if( $this->getRequest()->isPost() ){

            try {
                $user = new User();
                $user->id = (int)$this->getRequest()->post( 'id' );
                $user->email = $this->getRequest()->post( 'email' );
                $user->password = $this->getRequest()->post( 'password' );
                $user->role = 'ROLE_USER';

                $user->save();

                Service::get( 'security' )->clear();

                return $this->redirect( $this->generateRoute( 'login' ), 'The user data has been update successfully' );

            }
            catch( DatabaseException $e ) {
                $error = $e->getMessage();
            }
        }

        $currentUser = Service::get( 'security' )->getUser();
        $userEmail = $currentUser->email;
        $user = User::findByEmail( $userEmail );
        $segments = explode( '@', $userEmail );

        $user->name = $segments[ 0 ];

        $date[ 'updateUser' ] = $user;
        $date[ 'action' ] = $this->generateRoute( 'profile' );
        $date[ 'errors' ] = isset( $error ) ? $error : null;

        return $this->render( 'update.html', $date );
    }
}