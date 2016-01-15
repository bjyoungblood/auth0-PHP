<?php

namespace Auth0\SDK\API;

use Auth0\SDK\API\Helpers\ApiClient;
use Auth0\SDK\API\Header\ContentType;

class Users {

    protected $apiClient;

    public function __construct(ApiClient $apiClient) {
        $this->apiClient = $apiClient;
    }

    public function get($user_id) {

        $user_info = $this->apiClient->get()
            ->users($user_id)
            ->call();

        return $user_info;
    }

    public function update($user_id, $data) {

        $user_info = $this->apiClient->patch()
            ->users($user_id)
            ->withHeader(new ContentType('application/json'))
            ->withBody(json_encode($data))
            ->call();

        return $user_info;
    }

    public function create($data) {

        $user_info = $this->apiClient->post()
            ->users()
            ->withHeader(new ContentType('application/json'))
            ->withBody(json_encode($data))
            ->call();

        return $user_info;
    }

    public function search($params) {

        $client = $this->apiClient->get()
            ->users();

        foreach ($params as $param => $value) {
            $client->withParam($param, $value);
        }

        return $client->call();
    }

    public function deleteAll() {

        $this->apiClient->delete()
            ->users()
            ->call();
    }

    public function delete($user_id) {

        $this->apiClient->delete()
            ->users($user_id)
            ->call();
    }

    public function linkAccount($user_id, $post_identities_body) {

        return $this->apiClient->post()
            ->users($user_id)
            ->identities()
            ->withHeader(new ContentType('application/json'))
            ->withBody(json_encode($post_identities_body))
            ->call();
    }

    public function unlinkAccount($user_id, $provider, $identity_id) {

        return $this->apiClient->delete()
            ->users($user_id)
            ->identities($provider)
            ->addPathVariable($identity_id)
            ->call();
    }

    public function unlinkDevice($user_id, $device_id) {
        $this->apiClient->delete()
            ->users($user_id)
            ->devices($device_id)
            ->call();
    }

    public function deleteMultifactorProvider($user_id, $multifactor_provider) {
        $this->apiClient->delete()
            ->users($user_id)
            ->multifactor($multifactor_provider)
            ->call();
    }
}