<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Library\fpdf\FPDF;

class WelcomeController extends Controller
{
    //show public page
    public function index()
    {
        $articles = DB::select('select a.*,b.name,b.email from lib_articles a inner join users b on a.userID=b.ID order by a.id desc limit 10');
        return view('welcome',['articles' => $articles]);
    }

    //method to show article details
    public function getArticle(Request $request, $id){
        //run mysql
        $articles = DB::select('select a.*,b.name,b.email from lib_articles a inner join users b on a.userID=b.ID where a.id=?', [$id]);
        //show view
        return view('viewArticle',['articles' => $articles]);
    }

    //method to export article details to PDF
    public function getArticlePDF(Request $request, $id){
        //run mysql
        $articles = DB::select('select a.*,b.name,b.email from lib_articles a inner join users b on a.userID=b.ID where a.id=?', [$id]);
        //show view
        if (count($articles) > 0){
            $article = $articles[0];
            $pdf = new FPDF();
            $pdf->AddPage();
            //article title
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(0,10,$article->artTitle);
            // Line break
            $pdf->Ln(15);
            //get image
            $filename = glob( __DIR__ . '/../../../storage/app/images/' . 'img' . $id . '.*');
            if (count($filename) > 0){
                $pdf->Image($filename[0],null,null,190);
                $pdf->Ln(10);
            }

            //article body text
            $pdf->SetFont('Arial','',12);
            $pdf->MultiCell(0,5,$article->artText);
            //article author and timestamp
            $pdf->Ln(20);
            $pdf->SetFont('Arial','I',10);
            $pdf->Cell(0,10,"written by $article->name ( $article->email)");
            $pdf->Ln(5);
            $pdf->Cell(0,10, $article->currentTime);

            //clear output before pdf
            ob_get_clean();
            //output PDF
            $pdf->Output();
        }
        else{
            echo "This article does not exists!";
        }
    }

    //method to get articles RSS
    public function getArticleRSS(Request $request){
        //run mysql
        $articles = DB::select('select a.*,b.name,b.email from lib_articles a inner join users b on a.userID=b.ID order by a.id desc limit 10');
        
        //start XML element
        $feeds = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss></rss>');
        $feeds->addAttribute('version', '2.0');

        //create channel
        $channel = $feeds->addChild('channel');
        $channel->addChild('title', 'Newspaper RSS');
        $channel->addChild('link', '/newspaper');
        $channel->addChild('description', 'Feed RSS for NewsPaper test');

        // run articles list
        foreach($articles as $item)
        {
            //assign child items to the channel element
            $item_channel = $channel->addChild('item');
            $item_channel->addChild('title', $item->artTitle);
            $item_channel->addChild('link', 'http://newspaper/article/' . $item->id);
            $item_channel->addChild('description', $item->artText);
            $item_channel->addChild('pubDate', $item->currentTime);
            $item_channel->addChild('author', $item->email);
        }
        
        //clear output before xml
        ob_get_clean();
        // define the content for output
        header("content-type: application/rss+xml; charset=utf-8");
        // generate feed
        echo $feeds->asXML();
    }

    //method to activate account
    public function getActivation(Request $request, $id){
        //run mysql to activate user
        $affected = DB::update('update users set activation_token = "disabled", activated=true where (activation_token = ? and activated=false)', [$id]);
        //show view
        if ($affected){
            echo "Account activated. <a href='http://newspaper/home'>Go to main page.</a>";
        }
        else{
            if ($id == 'test'){
                echo 'Test OK';
            }
            else{
                echo "This account can't be activated or does not exist. <a href='http://newspaper/'>Go to main page.</a>";
            }
        }
    }
}
