import { Router } from '@angular/router';
import { TransactionService } from './../services/Transaction.service';
import { FraisService } from './../services/frais.service';
import { FormControl } from '@angular/forms';
import { Validators } from '@angular/forms';
import { FormGroup, FormBuilder } from '@angular/forms';
import { Component, OnDestroy, OnInit } from '@angular/core';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-depot',
  templateUrl: 'depot.page.html',
  styleUrls: ['depot.page.scss']
})
export class DepotPage implements OnDestroy, OnInit {
  montantCtrl = new FormControl(0, [Validators.required, Validators.min(5000)]);
  fraisCtrl = new FormControl(0);
  totalCtrl = new FormControl(0);
emetForm: FormGroup;
benForm: FormGroup;
submitted = false;
depot = {
  montant : 0,
  retraitClient: '',
  depotClient: ''
};
  constructor(
    private route: Router,
    private alert: AlertController,
    private fraisService: FraisService,
    private transService: TransactionService,
    private fb: FormBuilder) {
      const tabBar = document.getElementById('myTab');
      tabBar.style.display = 'none';
  }

  ngOnDestroy(){
    const tabBar = document.getElementById('myTab');
    tabBar.style.display = '';
  }


  ngOnInit(){
    this.initForm();
  }

  getFrais(){

    const montant = this.montantCtrl.value;
    if (montant >= 5000 && montant < 2000000)
    {
      this.fraisService.getFrais(montant).
        subscribe( data => {
          const frais = data['hydra:member'][0]['frais'];
          this.fraisCtrl.setValue(frais);
          this.totalCtrl.setValue(frais + montant);
        });
    }else if (montant >= 2000000){
      const frais = montant * 0.02;
      this.fraisCtrl.setValue(frais);
      this.totalCtrl.setValue(frais + montant);
    }
  }

  getMontant(){

    const montantT = this.totalCtrl.value;
    if (montantT >= 5850 && montantT < 2040000)
    {
      this.fraisService.getMonant(montantT).
        subscribe( data => {
          const frais = data['hydra:member'][0]['frais'];
          this.fraisCtrl.setValue(frais);
          this.montantCtrl.setValue( montantT - frais);
        });
    }else if (montantT >= 2020000){
      const montant = montantT / 1.02;
      this.fraisCtrl.setValue(montantT - montant);
      this.montantCtrl.setValue(montant);
    }
    else{

      this.fraisCtrl.setValue(0);
      this.montantCtrl.setValue(0);
    }
  }


  initForm(){

    this.emetForm = this.fb.group({
      nomComplet: [''],
      nom: ['', Validators.required],
      prenom: ['', Validators.required],
      cni: ['', Validators.required],
      telephone: ['', [Validators.required]]
    });

    this.benForm = this.fb.group({
      nomComplet: [''],
      nom: ['', Validators.required],
      prenom: ['', Validators.required],
      telephone: ['', [Validators.required]]
    });
  }

  public get f1(): any{
    return this.emetForm.controls;
  }
  public get f2(): any{
    return this.benForm.controls;
  }

  submitForm(){
    // console.log(this.emetForm.get('nom').value);
    this.submitted = true;
    this.emetForm.get('nomComplet').patchValue((this.emetForm.get('nom').value).toUpperCase()  + ' ' + this.emetForm.get('prenom').value);
    this.benForm.get('nomComplet').patchValue((this.benForm.get('nom').value).toUpperCase()  + ' ' + this.benForm.get('prenom').value);
    if (this.benForm.invalid || this.emetForm.invalid){
      return;
    }
    this.depot.depotClient = this.emetForm.value;
    this.depot.montant = this.montantCtrl.value;


    this.depot.retraitClient = this.benForm.value;
    console.log(this.depot);
    this.sendDepot(this.depot);
    // this.transService.addTransaction(this.depot).
    //     subscribe(
    //       data => {
    //       alert('Transaction Ajouté');
    //     },
    //       err => {
    //         console.log(err);
    //       }
    //     );

  }



  async sendDepot(data: any) {
    const msgBene = `
    <small>ÉMETTEUR</small>
      <br><span>${data.depotClient.nomComplet}</span>
      <br>
    <small>TELEPHONE</small>
      <br><span>${data.depotClient.telephone }</span>
      <br>
    <small>MONTANT</small>
      <br><span>${this.montantCtrl.value}</span>
      <br>
    <small>BÉNÉFICIAIRE</small>
      <br><span> ${data.retraitClient.nomComplet }</span>
      <br>
    <small>TELEPHONE</small>
      <br><span>${data.retraitClient.telephone }</span>
      <br>
    <small>N° CNI</small>
      <br><span>${data.retraitClient.cni }</span>
      <br>
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
            // tslint:disable-next-line:max-line-length
            // this.allUserSrv.addData('transactions/depot', data)
            // .subscribe(result => {
            //   console.log(result);
            // },
            // err => {
            //   console.log(err);
            // });
           // this.depot.retraitClient = this.benForm.value;

            this.transService.addTransaction(this.depot).
                subscribe(
                  (data) => {
                    const msg = `
                    <small>CODE : </small>
                      <br><span>${data.code}</span>
                      <br>
                      <br>
                    `;
                    console.log(data);
                    this.getAlert(msg);
                    this.resetForm();
                   // alert('Transaction Ajouté');
                },
                  err => {
                    console.log(err);
                  }
                );

          },
        }
      ]
    });
    await alert.present();
  }



  async getAlert(msg){


    const alert = await this.alert.create({
      header: 'Transfert Reussi',
      cssClass: 'my-custom-class',
      message: msg,
      buttons: [
        {
          cssClass: 'bntl',
          text: 'Fermer',
          handler: () => {
            console.log('Fermer');
          }
        },
        // {
        //   cssClass: 'bton',
        //   text: 'OK',
        //   handler: () => {

        //   },
        // }
      ]
    });
    await alert.present();
  }

  resetForm(): void{
    this.emetForm.reset();
    this.benForm.reset();
  }


  gotoToTransactions(){
    this.route.navigate(['/tabs/home/transaction']);
  }
}
