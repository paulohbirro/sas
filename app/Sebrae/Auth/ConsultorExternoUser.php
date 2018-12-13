<?php

namespace App\Sebrae\Auth;

use App\Eloquent\Models\Consultor;
use Illuminate\Contracts\Auth\Authenticatable;

class ConsultorExternoUser implements Authenticatable
{
    /**
     * Consultor Eloquent Model
     *
     * @var Consultor
     */
    private $consultor;

    /**
     * SebraeUser constructor.
     *
     * @param Consultor $consultor
     */
    public function __construct(Consultor $consultor)
    {
        $this->consultor = $consultor;
    }

    public function getConsultor()
    {
        return $this->consultor;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->consultor->cpf;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return null;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}