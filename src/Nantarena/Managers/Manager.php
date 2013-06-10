<?php

namespace Nantarena\Managers;

abstract class Manager {
    protected function create($data);
    protected function update($data);
    protected function delete($data);
    protected function getAll($data);
}