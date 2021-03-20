import { FraisService } from './../services/frais.service';
import { FormControl } from '@angular/forms';
import { Component } from '@angular/core';

@Component({
  selector: 'app-calculateur',
  templateUrl: 'calculateur.page.html',
  styleUrls: ['calculateur.page.scss']
})
export class CalculateurPage {
 mntCtl = new FormControl('');
 frais = null;
 soldeCtl = new  FormControl('');
  constructor(private fraisService: FraisService) {}


  getFrais(){

    const montant = this.mntCtl.value;
    if (montant >= 5000 && montant < 2000000)
    {
      this.fraisService.getFrais(montant).
        subscribe( data => {
          const frais = data['hydra:member'][0]['frais'];
          this.frais = frais;
        });
    }else if (montant >= 2000000){
      const frais = montant * 0.02;
      this.frais = frais;
    }
    else{
      this.frais = null;
    }
  }

}
