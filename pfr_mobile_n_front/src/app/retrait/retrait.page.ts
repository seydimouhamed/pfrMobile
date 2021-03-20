import { TransactionService } from './../services/Transaction.service';
import { FormControl, Validators } from '@angular/forms';
import { Component, OnDestroy } from '@angular/core';
import { subscribeOn } from 'rxjs/operators';

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
      console.log(this.data.id + ' ' + this.cniRetrait.value);
      const data = {
        retraitClient:
        {
          id: `/api/clients/${this.data.retraitClient.id}`,
          cni: this.cniRetrait.value
        }
      };

     // console.log(this.data.id);

     // return;
      this.transService.puTransaction(this.data.id, data).
            subscribe(
              (data) => {
                alert('retrait fait avec success');
            });
    }
  }
}
