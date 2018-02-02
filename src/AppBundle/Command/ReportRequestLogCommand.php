<?php


namespace AppBundle\Command;


use AppBundle\Service\RequestLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReportRequestLogCommand extends Command
{
    /** @var RequestLogger */
    private $requestLogger;

    public function __construct(RequestLogger $requestLogger)
    {
        $this->requestLogger = $requestLogger;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:request_log:send_report')
            ->setDescription('Sends report to email')
            ->addOption(
                'email',
                null,
                InputOption::VALUE_REQUIRED,
                'Where to send email?',
                1
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getOption('email');
        $dateFrom = new \DateTime('- 1 hour');
        $dateTo = new \DateTime('now');
        try{
            $this->requestLogger->sendReport($dateFrom, $dateTo, $email);
        }catch (\Exception $exception){
            dump($exception);
        }
        $output->writeln('Email sent');
    }
}