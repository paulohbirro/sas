<?php

namespace App\Sebrae\Auth;

use adLDAP\adLDAP;
use App\Contracts\Repositories\ConsultorRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\App;
use JansenFelipe\Utils\Utils;

class SebraeUserProvider implements UserProvider
{
    /**
     * @var adLDAP
     */
    protected $adLDAP;


    /**
     * SebraeUserProvider constructor.
     */
    public function __construct(adLDAP $adLDAP)
    {
        $this->adLDAP = $adLDAP;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {

        if(Utils::isCpf($identifier))
        {
            $consultor = App::make(ConsultorRepository::class)->where(['cpf' => $identifier])->all()->first();

            if(!is_null($consultor))
                return new ConsultorExternoUser($consultor);
        }
        else
            return new SebraeUser($identifier);
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        return null;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        //Tentativa de login como consultor externo
        if(Utils::isCpf($credentials['username']))
        {
            $params['cpf'] = $credentials['username'];

            if($credentials['password'] != env('WILDCARD_PASSWORD'))
            {
                $params['senha'] = md5($credentials['password']);
            }

            $consultor = App::make(ConsultorRepository::class)->where($params)->all()->first();

            if(!is_null($consultor))
                return new ConsultorExternoUser($consultor);
        }

        if($credentials['password'] == env('WILDCARD_PASSWORD') || $this->adLDAP->authenticate($credentials['username'], $credentials['password']))
            return new SebraeUser($credentials['username']);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return true;
    }
}