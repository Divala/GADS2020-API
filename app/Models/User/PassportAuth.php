<?php
/**
 * Created by PhpStorm.
 * User: mathewsdivala
 * Date: 2019-03-11
 * Time: 08:27
 */

namespace App\Models\User;


use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

class PassportAuth
{

    use HandlesOAuthErrors;

    private $jwt;
    private $server;
    private $tokens;
    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->jwt = resolve(JwtParser::class);
        $this->server = resolve(AuthorizationServer::class);
        $this->tokens = resolve(TokenRepository::class);
        $this->request = $request;
    }

    public function issueToken(PassportClient $passportClient, string $username, string $password)
    {
        $request = $this->request->withParsedBody([
            "username" => $username,
            "password" => $password,
            "client_id" => $passportClient->id,
            "client_secret" => $passportClient->secret,
            "grant_type" => "password"
        ]);

        $response = $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        })->content();

        return json_decode($response);
    }
}