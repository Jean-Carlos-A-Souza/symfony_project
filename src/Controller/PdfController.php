<?php

namespace App\Controller;

use App\Repository\ContatoRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf", name="pdf")
     * @IsGranted("ROLE_ADMIN")
     */
    public function browser(ContatoRepository  $contatoRepo): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $data['contatos']=$contatoRepo->findAll();
        $data['title'] = 'Lista de Contatos de Clientes';
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('contato/mypdf.html.twig', $data );

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("Clientes_pdf.pdf", [
            "Attachment" => false
        ]);

        exit(0);
    }

}