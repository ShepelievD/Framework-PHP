<?php

namespace Framework\Security;

use Framework\DI\Service;
use Blog\Model\User;
use Framework\Exception\AccessDenyException;
use Framework\Exception\SecurityException;

/**
 * Class Security
 * @package Framework\Security
 */

class Security {

    /**
     * Current session
     * @var null
     */

    private $session = null;

    /**
     * Array of user's role
     * @var array
     */

    protected static $allowedGrants = [
        'poster' => 'ROLE_USER',
    ];

    /**
     * Security constructor.
     */

    public function __construct() {
        $this->session = Service::get( 'session' );
        $this->session->putParameter( 'isAuthenticated', false, false );
    }

    /**
     * Clear session
     */
    public function clear() {
        $this->session->putParameter( 'isAuthenticated', false );
        $this->session->removeParameter( 'userName' );
        $this->session->removeParameter( 'userRole' );
    }

    /**
     * Serves for checking authentication
     *
     * @return mixed
     */

    public function isAuthenticated() {
        return $this->session->getParameter( 'isAuthenticated' );
    }

    /**
     * Sets current user
     *
     * @param $user
     */

    public function setUser($user) {
        $this->session->putParameter( 'userName', $user->email );
        $this->session->putParameter( 'userRole', $user->role );
        $this->session->putParameter( 'isAuthenticated', true );
    }

    /**
     * Returns current user or null if not authenticated
     *
     * @return User|null
     */

    public function getUser() {
        $result = null;
        if ($this->session->getParameter( 'isAuthenticated' )) {
            $user = new User();
            $user->email = $this->session->getParameter( 'userName' );
            $result = $user;
        }
        return $result;
    }

    /**
     * Generates token( md5 algorithm )
     *
     * @return string
     */

    public function generateToken()
    {
        $token = md5(mktime());
        $this->session->putParameter( 'token', $token );
        return $token;
    }

    /**
     * Serves for checking token correct or not
     *
     * @return bool
     */
    public function isTokenCorrect() {
        $request = Service::get( 'request' );
        $token   = null;
        if ($request->parameterExist( 'token' )) {
            $token = $request->get( 'token' );
        }
        if ( $token != null ) {
            $tokenFromSession = $this->session->getParameter( 'token' );
            return $tokenFromSession == $token?true:false;
        }
        else {
            return true;
        }
    }

    /**
     * Checks token, if token does not correct throws an exception
     *
     * @throws SecurityException
     */
    public function checkToken(){
        if ( !$this->isTokenCorrect() ) {
            throw new SecurityException( 'Invalid token' );
        }
    }

    /**
     * Checks does user has grants
     *
     * @param $user
     * @return bool
     */

    public function checkGrants( $user ){

        $result = false;

        if( !is_null( $user )) {
            $userRole = $user->role;

            foreach (self::$allowedGrants as $key => $role) {
                if ($userRole = $role) {
                    $result = true;
                }
            }
        }

        return $result;
    }
}