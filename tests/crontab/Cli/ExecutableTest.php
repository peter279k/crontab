<?php
/**
 * This file is part of SebastianFeldmann\Crontab.
 *
 * (c) Sebastian Feldmann <sf@sebastian-feldmann.info>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SebastianFeldmann\Crontab\Cli;

use SebastianFeldmann\Crontab\Job;

/**
 * Class ExecutableTest
 *
 * @package SebastianFeldmann\Crontab
 */
class ExecutableTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests Executable::createCommandLine
     */
    public function testListJobs()
    {
        $cmd  = new Executable(SF_CRONTAB_TEST_FILES . '/bin');
        $cmd->listJobs();
        $line = $cmd->createCommandLine();

        $this->assertEquals(SF_CRONTAB_TEST_FILES . '/bin/crontab -l', $line->getCommand());
    }

    /**
     * Tests Executable::createCommandLine
     */
    public function testListJobsForUser()
    {
        $cmd  = new Executable(SF_CRONTAB_TEST_FILES . '/bin');
        $cmd->listJobs()->forUser('root');
        $line = $cmd->createCommandLine();

        $this->assertEquals(SF_CRONTAB_TEST_FILES . '/bin/crontab -u \'root\' -l', $line->getCommand());
    }

    /**
     * Tests Executable::createCommandLine
     */
    public function testAppendJob()
    {
        $expected = '(' . SF_CRONTAB_TEST_FILES
                        . "/bin/crontab -l && echo '1 2 3 * * echo 1" . PHP_EOL
                        . "') | " . SF_CRONTAB_TEST_FILES . '/bin/crontab -';

        $cmd = new Executable(SF_CRONTAB_TEST_FILES . '/bin');
        $cmd->addJob(new Job('1 2 3 * *', 'echo 1', []));
        $line = $cmd->createCommandLine();

        $this->assertEquals($expected, $line->getCommand());
    }
}
