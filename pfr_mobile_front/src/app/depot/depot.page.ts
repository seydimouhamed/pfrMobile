import { FraisService } from './../services/frais.service';
import { FormControl } from '@angular/forms';
import { Validators } from '@angular/forms';
import { FormGroup, FormBuilder } from '@angular/forms';
import { Component, OnDestroy, OnInit } from '@angular/core';

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
    private fraisService: FraisService,
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
      nomComplet: ['', Validators.required],
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
    if (this.benForm.invalid || this.emetForm.invalid){
      return;
    }
    this.emetForm.get('nomComplet').patchValue(this.emetForm.get('nom').value + ' ' + this.emetForm.get('prenom').value);
    this.depot.depotClient = this.emetForm.value;
    this.depot.montant = this.montantCtrl.value;

    this.benForm.get('nomComplet').patchValue(this.benForm.get('nom').value + ' ' + this.benForm.get('prenom').value);

    this.depot.retraitClient = this.benForm.value;



  }
}
