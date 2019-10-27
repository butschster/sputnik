<?php

namespace Tests\Unit\Utils\SSH\ValueObjects;

use Domain\SSH\ValueObjects\PublicKey;
use Tests\TestCase;

class PublicKeyTest extends TestCase
{
    function test_a_fingerpring_can_be_generated()
    {
        $key = new PublicKey('test', $this->getPublicKey());

        $this->assertEquals('b7:97:56:7d:10:11:8e:83:db:ab:2c:1f:33:98:30:3d', $key->getFingerprint());
    }

    function test_compare_keys()
    {
        $key = new PublicKey('test', $this->getPublicKey());
        $key1 = new PublicKey('test', $this->getPublicKey());
        $key2 = new PublicKey('test', 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDBi9tKuZrnIVMXMMjJDQG+OOQOf3g3Ky/pYWXP+H0YOI+ISHOJ+5tQUdtGAF8SBXQr6MkNEh7QjUH+Nbcl/J+Yc/ZjnXMzRjNJXRJlBo9R2oet8BVromzxiB4LRApkjFyDOcr4INOw8Z7hPJXOsYud7wW1PvYX1ojEgk2HRiR1BHssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDBi9tKuZrnIVMXMMjJDQG+OOQOfzg3Ky/pYWXP+H0YOI+ISHOJ+5tQUdtGAF8SBXQr6MkNEh7QjUH+Nbcl/J+Yc/ZjnXMzRjNJXRJlBo9R2oet8BVromzxiB4LRApkjFyDOcr4INOw8Z7hPJXOsYud7wW1PvYX1ojEgk2HRiR1BHTVHQFh/c+mvfc1KEVa18kKomLRTs0ndTtSof1ZWTZUduy8o+rPGBQ7deZu0HHwE3ekQax7AVWHCvFOtghGGUCG+vSwo2OELrourruK95FlH72rlrEEUyM7PDmgLaQTWt7R0J29cfpg2hiYmco0MzFeBP0WOJUpSTcHwoRe1WDH sputnik@localhostTVHQFh/c+mvfc1KEVa18kKomLRTs0ndTtSof1ZWTZUduy8o+rPGBQ7deZu0HHwE3ekQax7AVWHCvFOtghGGUCG+vSwo2OELrourruK95FlH72rlrEEUyM7PDmgLaQTWt7R0J29cfpg2hiYmco0MzFeBP0WOJUpSTcHwoRe1WDH sputnik@localhost
');

        $this->assertTrue($key->is($key1));
        $this->assertFalse($key->is($key2));
    }
}
