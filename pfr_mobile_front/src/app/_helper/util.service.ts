import { FraisService } from './../services/frais.service';

import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UtilService {

  constructor(
    private fraisService: FraisService) { }

  getFrais(montant){

    if (montant >= 5000 && montant < 2000000)
    {
      this.fraisService.getFrais(montant).
        subscribe( data => {
          const frais = data['hydra:member'][0]['frais'];

        });
    }else if (montant >= 2000000){
      const frais = montant * 0.02;
      // this.fraisCtrl.setValue(frais);
      // this.totalCtrl.setValue(frais + montant);
    }
  }
}
