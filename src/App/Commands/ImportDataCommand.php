<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use App\Entity\Table;
use App\Entity\Booking;
use App\Entity\Guest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Debug\Debug;

#[AsCommand(
    name: 'app:import-data',
    description: 'Import Data.',
    hidden: false,
    aliases: ['app:add-user']
)]

class ImportDataCommand extends Command
{
    protected static $defaultName = 'app:import-data';
    private $entityManager;
    private $params;


    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
        $this->params = $params;



        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('Import-Data')
            ->setDescription('Imports data from sample_data.csv into the database.')
            ->setHelp('This command allows you to import data from sample_data.csv into the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $row = 1;

        $progressBar = new ProgressBar($output);

        $progressBar->start();

       $csvFile =  $_SERVER['PROJECT_ROOT'].'/sample_data.csv';
        if (($handle = fopen($csvFile, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);

                if ($row !== 1) {
                        $tableNo = $data[5];
                        $maxGeuest = $data[6];
                        $firstName = $data[2];
                        $lastName = $data[3];
                        $email = $data[4];
                        $seatedAt = new \DateTimeImmutable($data[0] ." ". $data[1]);
                        $totalAmount = $data[7]*100;

                        $tableRepo = $this->entityManager->getRepository(Table::class);
                        $tableData = $tableRepo->findOneBy(['maxGuests' => $maxGeuest,'number'=>$tableNo]);

                        if (!$tableData) {
                            $tabledata = new Table();
                            $tabledata->setNumber($tableNo);
                            $tabledata->setMaxGuests($maxGeuest);

                            $this->entityManager->persist($tabledata);

                            $this->entityManager->flush();

                            $table_id = $tabledata->getId();
                        }


                        $guestRepo = $this->entityManager->getRepository(Guest::class);
                        $guestData = $guestRepo->findOneBy(['email' => $email]);

                        if (!$guestData) {

                            $guestdata = new Guest();
                            $guestdata->setFirstName($firstName);
                            $guestdata->setLastName($lastName);
                            $guestdata->setEmail($email);

                            $this->entityManager->persist($guestdata);


                            $this->entityManager->flush();

                            $userId = $guestdata->getId();
                        }


                        $bookingdata = new Booking();
                        if (!$guestData) {
                            $bookingdata->setBookedBy($guestdata);
                        } else {
                            $bookingdata->setBookedBy($guestData);
                        }
                        if (!$tableData) {
                            $bookingdata->setReservedTable($tabledata);
                        } else {
                            $bookingdata->setReservedTable($tableData);
                        }
                        $bookingdata->setSeatedAt($seatedAt);
                        $bookingdata->setPartySize($maxGeuest);
                        $bookingdata->setTotalAmount($totalAmount);


                        $this->entityManager->persist($bookingdata);

                        $this->entityManager->flush();


                }

                $progressBar->advance();


                $row++;
            }

        $progressBar->finish();
        fclose($handle);
}
        $output->writeln(['',
        'Data Imported Successfully']);
        return Command::SUCCESS;
    }
}
