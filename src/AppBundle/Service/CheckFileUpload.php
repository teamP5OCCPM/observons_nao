<?php

namespace AppBundle\Service;

class CheckFileUpload
{
    public function checkFileCol(array $tab)
    {
        // On recupere la premiere ligne du tableau
        $first_row = array_shift($tab);

        if ($first_row['reign'] === 'REGNE' && $first_row['phylum'] === 'PHYLUM' && $first_row['ranking'] === 'ORDRE') {
            return true;
        }
        return false;
    }
}
