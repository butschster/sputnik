<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\Models\User::class)->create([
            'email' => 'admin@site.com',
            'name' => 'Pavel Buchnev',
        ]);

        $server = factory(\App\Models\Server::class)->create([
            'name' => 'test',
            'ip' => '167.71.3.113',
            'public_key' => <<<EOL
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCeqP3sP/JNIMZQLGIJmOWHM9PspSRvMMKGq76bhL6iSPKE5Dw+xkORcBt29l7UC+RDdqiwi+Zl42eWGXwPK1FV7RiK6ujw//fyyMmfTccABmjGhcV/xDLuQoGB64CPy1lIhhFZgGXeudQxfq4oudESf7WkhcRIoPk14nE7b5AGwzd2MxzTSJevYZ7O+D+V2W1MIYwfGOgUwAIRkHQb/oxac5WqzjNpJK79mcmSU8lWbkGowj21UOC5+BqgObxGnVFAbxxIF9k0PC1U2WnZGDffG93guLQn0IBqh6sm/EqsuEzGgDzL85+G6NxtwBAMG6pyXrfol4Ug2hniiZ0xunz3 root@ubuntu-s-1vcpu-1gb-ams3-06
EOL
        ,
            'private_key' => <<<EOL
-----BEGIN OPENSSH PRIVATE KEY-----
b3BlbnNzaC1rZXktdjEAAAAACmFlczI1Ni1jdHIAAAAGYmNyeXB0AAAAGAAAABA8zASqWa
Q724xpYwgmY+uvAAAAEAAAAAEAAAEXAAAAB3NzaC1yc2EAAAADAQABAAABAQCeqP3sP/JN
IMZQLGIJmOWHM9PspSRvMMKGq76bhL6iSPKE5Dw+xkORcBt29l7UC+RDdqiwi+Zl42eWGX
wPK1FV7RiK6ujw//fyyMmfTccABmjGhcV/xDLuQoGB64CPy1lIhhFZgGXeudQxfq4oudES
f7WkhcRIoPk14nE7b5AGwzd2MxzTSJevYZ7O+D+V2W1MIYwfGOgUwAIRkHQb/oxac5Wqzj
NpJK79mcmSU8lWbkGowj21UOC5+BqgObxGnVFAbxxIF9k0PC1U2WnZGDffG93guLQn0IBq
h6sm/EqsuEzGgDzL85+G6NxtwBAMG6pyXrfol4Ug2hniiZ0xunz3AAAD4JDRh91DoDMMFB
iFPgtpxRMBtFrSwiWk2gtcIjnALc8OWEgF4WYHoSfLdK4VsXZm8k3dMdTlaVYt5xlD455Y
bdj6BRDP6s7ypgE4Swx8lA0SK3aUiQ1MebN/VaiIFRnoLSu8Dv8YHY8qyITh+jNl5OF2DL
SQu1qzvthiSYW+zSjQB0p4zKqhQ3llFf+klrKIFbflWtIuihHhLc6G0+G7JdUDxrQuTrkq
QBQ9230jVS/rVH7/6zjnM8qIv689Eqa6bX77lQXMsSpM+C7Ogqlllk4AVqMwsKu6xmCqcU
u+TmZTv//x5URXaN6s+kZ6RCtxKkTiBMlNSFCSXJZ/72mwGU/NLdGnG9JsJPpW2WfUg14m
9jezeOZn1kXem5SzilI8tPzhzrR2tJMvcO1ZE8pDlzfbU2q4QelpYX8m89eoC9ggl6H9OO
vfP7hLz9oDMQS6fsrPrzWZsaPlcVUn+XOUu2OJz9WDVw19aCz4XKoRc3s3JIsnXTjMYVvw
JutvgshKcgFuGRkbCpLDSSB/o+QHgTe37gSxqxayMl1YHZduDP7mVcWulHtmtC9+8aRXrb
AzXFdDj+4TDCz9SREipnvRnObdeOFcy0aMbZduycn89Sm9+1O3DwzC5Wtp1KYwNHb5RgNd
YnFqRAKwwWRTY2AaLPxLQMVqexNDGmUmIfg7A1Zvp0N+qL4YUlZvvaEMJtwyacwdkOsu+a
L53VdkaET+sDL8ebptqALAFWXQQzF6OeRZxQlNJbk4BM1wq/BcL68a2kp1ogxyJrdIeZ6l
QTlPLncmRsnapU4aasmEevyeqPyDHTSLQob84p1Y2b+UnCy1u+SDCv6F4LqDQjntblR6V5
7yKQuOxhdjZYKWKnzk0dKYdGnFin68Q4VfdTouz5bFsuX1NajqRBgce3pxbcu8T2ZMH1Yi
6/iWQ/tXGmVGjjNkiMZlZNjP6JZgkAMaUDNwMluQwxRcaxggovLs7RW5A6Hs/pvP6+54mT
R7HV2VftVlnBmEOreV0LrkPlGJzpKBFfqrnUBbLlgGYYHQ8W+lCfqxefbmZkj1EJ4+FIdD
kkSNqonPVNNtMDHeAuuYb6WVI9IKk3Mosfz+y0XWJsvo+FIIHKtYrD9urt+BaadVG6F1mY
GjYIB2h6Bc5BJiZ1M1UolyjjeKjRuvl25Qrkc5vFn9eUUaPRXleGJ7dL/58mWHqxwGHRuT
DBLZSN9ZDvTM/UM+f8gBL5whSRWepIIQC1q/jHeKGefqkRxfTBkQNJs4uwMtIfuAQtN4v9
YBoLtBFRSfuO+CzI19K97rt8Xss5cP0ONgk7694SoI430Y26YT
-----END OPENSSH PRIVATE KEY-----
EOL
,
            'key_password' => 'password'
        ]);
    }
}
