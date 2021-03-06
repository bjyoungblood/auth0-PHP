<?php
namespace Auth0\Tests;

use Auth0\SDK\Auth0Api;

abstract class BasicCrudTest extends ApiTests {

    protected abstract function getApiClient();
    protected abstract function getCreateBody();
    protected abstract function getUpdateBody();
    protected abstract function afterCreate($entity);
    protected abstract function afterUpdate($entity);

    protected function getId($entity) {
        return $entity['id'];
    }

    public function testAll() {

        $client = $this->getApiClient();

        $created = $client->create($this->getCreateBody());

        $all = $client->getAll();

        $found = false;
        foreach ($all as $value) {
            if ($this->getId($value) === $this->getId($created)) {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Created item not found');

        $this->afterCreate($created);

        $client3 = $client->update($this->getId($created), $this->getUpdateBody());

        $get = $client->get($this->getId($created));
        $this->afterUpdate($get);

        $client->delete($this->getId($created));
    }
}