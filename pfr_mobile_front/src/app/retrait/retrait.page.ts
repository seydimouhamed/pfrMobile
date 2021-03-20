import { Router } from '@angular/router';
import { TransactionService } from './../services/Transaction.service';
import { FormControl, Validators } from '@angular/forms';
import { Component, OnDestroy } from '@angular/core';
import { subscribeOn } from 'rxjs/operators';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-retrait',
  templateUrl: 'retrait.page.html',
  styleUrls: ['retrait.page.scss']
})
export class RetraitPage implements OnDestroy{

  codeCtrl = new FormControl('');
  cniRetrait = new FormControl(0, [
    Validators.required,
    Validators.pattern('^[0-9]*$'),
    Validators.minLength(17)]);
  data: any;
  constructor(
    private route: Router,
    private alert: AlertController,
    private transService: TransactionService ) {
    const tabBar = document.getElementById('myTab');
    tabBar.style.display = 'none';
  }

  ngOnDestroy(){

    const tabBar = document.getElementById('myTab');
    tabBar.style.display = '';
  }
  getDataTransaction(){
    const code = this.codeCtrl.value;
    if (code){
      this.transService.getTransactionByCode(code).
          subscribe( data => {
            if (data)
            {
              this.data = data['hydra:member'][0];
              console.log(this.data);
            }
          });
    }
  }

  doneRetrait(){
    if (this.cniRetrait.valid){
      // console.log(this.data.id + ' ' + this.cniRetrait.value);
      const data = {
        retraitClient:
        {
          id: `/api/clients/${this.data.retraitClient.id}`,
          cni: this.cniRetrait.value
        }
      };
      console.log(this.data);

      this.sendRetrait(data);
      // this.transService.puTransaction(this.data.id, data).
      //       subscribe(
      //         (data) => {
      //           alert('retrait fait avec success');
      //       });
    }
  }
  async sendRetrait(data: any) {
    const msgBene = `
    <small>BÉNÉFICIAIRE</small>
      <br><span> ${this.data.retraitClient.nomComplet }</span>
      <br>
    <small>TELEPHONE</small>
      <br><span>${this.data.retraitClient.telephone }</span>
      <br>
    <small>N° CNI</small>
      <br><span>${this.data.retraitClient.cni }</span>
      <br>
    <small>MONTANT</small>
      <br><span>${this.data.montantRetrait}</span>
      <br>
    <small>ÉMETTEUR</small>
      <br><span>${this.data.depotClient.nomComplet}</span>
      <br>
    <small>TELEPHONE</small>
      <br><span>${this.data.depotClient.telephone }</span>
      <br><br>
    `;
    // const msgEme = `
   // <div class="info-transe"><small>Émetteur</small><br>
   //     <span>${data.clientDepot.nomComplet}</span><br><br><small>MONTANT A RECEVOIR</small><br><span>${data.montant}</span><br><br><small>TELEPHONE</small><br><span>${data.retraitClient.telephone}</span><br><br><small>N° CNI</small><br><span>${ data.retraitClient.CNI }</span><br><br>${msgBene}</div>`;
    const alert = await this.alert.create({
      header: 'Confirmation',
      cssClass: 'my-custom-class',
      message: msgBene,
      buttons: [
        {
          cssClass: 'bntl',
          text: 'Annuler',
          handler: () => {
            console.log('Let me think');
          }
        },
        {
          cssClass: 'bton',
          text: 'Confirmer',
          handler: () => {
            this.transService.puTransaction(this.data.id, data).
            subscribe(
              (data) => {
               this.resetform();
            });
          },
        }
      ]
    });
    await alert.present();
  }

  resetform(){
    this.cniRetrait.reset();
    this.codeCtrl.reset();
  }

  gotoToTransactions(){
    this.route.navigate(['/tabs/home/transaction']);
  }
}
