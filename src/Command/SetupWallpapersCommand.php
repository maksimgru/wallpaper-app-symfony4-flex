<?php

namespace App\Command;

use App\Entity\Wallpaper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
//use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetupWallpapersCommand extends Command
{
    /**
     * @var string $wallpaperBaseDir
     */
    private $wallpaperBaseDir;
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * Create new SetupWallpapersCommand instance.
     *
     * @param string $wallpaperBaseDir
     * @param EntityManagerInterface $em
     *
     */
    public function __construct ($wallpaperBaseDir, EntityManagerInterface $em)
    {
        parent::__construct();
        $this->wallpaperBaseDir= $wallpaperBaseDir;
        $this->em = $em;
    }

    /**
     * This is Description of configure
     *
     * @return void
     *
     */
    protected function configure()
    {
        $this
            ->setName('app:setup-wallpapers')
            ->setDescription('...')
        ;
    }

    /**
     * This is Description of execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return boolean
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $wallpapers = glob($this->wallpaperBaseDir . '/*.*');
        $wallpaperCount = count($wallpapers);

        if ($wallpaperCount === 0) {
            $io->warning('No wallpapers found');
            return false;
        }

        $io->title('Importing Wallpapers in DataBase');
        $io->progressStart($wallpaperCount);

        $fileNames = [];

        foreach ($wallpapers as $wallpaper) {
            sleep(1);
            $pathinfo = pathinfo($wallpaper);
            $fileName = $pathinfo['basename'];
            $fileTitle= ucwords(trim(preg_replace('/(_|-)+/', ' ', $pathinfo['filename'])));

            $imagesize = getimagesize($wallpaper);
            $width = $imagesize[0];
            $height = $imagesize[1];

            $wp = (new Wallpaper())
                ->setFilename($fileName)
                ->setTitle($fileTitle)
                ->setWidth($width)
                ->setHeight($height)
                ->setCreatedAt()
                ->setUpdatedAt()
            ;

            $this->em->persist($wp);

            $fileNames[] = [$fileTitle, $fileName, $width, $height];

            $io->progressAdvance();
        }

        $io->progressFinish();

        $table = new Table($output);
        $table
            ->setHeaders(['File Title', 'File Name', 'Width (px)', 'Height (px)'])
            ->setRows($fileNames)
        ;
        $table->render();

        $io->success(sprintf('Added %d wallpapers, nice one.', $wallpaperCount));

        //$this->em->flush();

        return true;
    }

}
