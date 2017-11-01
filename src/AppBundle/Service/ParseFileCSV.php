<?php

namespace AppBundle\Service;


class ParseFileCSV
{
    public function parseFile($file)
    {
        // Tableau qui va contenir tous les éléments extraits du fichier CSV
        $tabResults = [];
        $row = 0; // Représente la ligne

        // Extraction du fichier
        if(($handle = fopen($file, "r")) !== false)     // lecture du fichier
        {
            while(($data = fgetcsv($handle, 2048, ";")) !== false) // Éléments séparés par ,
            {
                $num = count($data); // Nombre d'éléments sur la ligne traitée

                // Vérification au niveau de la première ligne à effectuer avec exception dans le cas
                // ou il y aurait une erreur

                $row++;

                // On récupère toutes les informations dans un tableau $tabResults
                for($c = 0; $c < $num; $c++)
                {
                    $tabResults[$row] = [
                        'reign' => utf8_encode($data[0]),
                        'phylum' => utf8_encode($data[1]),
                        'ranking' => utf8_encode($data[3]),
                        'family' => utf8_encode($data[4]),
                        'lb_name' => utf8_encode($data[9]),
                        'lb_author' => utf8_encode($data[10]),
                        'species' => utf8_encode($data[13]),
                        'cd_ref' => $data[7]
                    ];
                }
            }

            fclose($handle);
        }


        $tabFinal =[];

        // On parse le tableau pour supprimer tous les doublons
        foreach($tabResults as $element)
        {
            $tabFinal[$element['cd_ref']] = $element;
        }




        return $tabFinal;
    }
}