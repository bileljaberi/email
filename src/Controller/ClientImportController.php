<?php

namespace App\Controller;


use App\Entity\UserClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;

#[Route('api/clients')]
class ClientImportController extends AbstractController
{
    #[Route('/import', name: 'clients_import', methods:['POST'])]

    public function importAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $file = $request->files->get('file');

        if (!$file) {
            return new Response('pas de fichier pour importer');
        }

        $spreadsheet = IOFactory::Load ($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();

        
        

        foreach ($worksheet->getRowIterator(2) as $row) {
            $data = [];
            foreach ($row->getCellIterator() as $cell) {
                $data[] = $cell->getValue();
            }
            if (count($data) === 5) {
                $Userclient = new UserClient();
                $Userclient->setPrenom($data[0]);
                $Userclient->setNom($data[1]);
                $Userclient->setEmail($data[2]);
                $Userclient->setAdresse($data[3]);
                $Userclient->setCodePostal($data[4]);



                $entityManager->persist($Userclient);
            }
        }

        $entityManager->flush();

        return new Response('Data imported successfully', Response::HTTP_CREATED);
    }
}