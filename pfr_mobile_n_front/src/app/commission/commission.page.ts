import { Component } from '@angular/core';
import { ActivatedRoute, Data } from '@angular/router';

@Component({
  selector: 'app-commission',
  templateUrl: 'commission.page.html',
  styleUrls: ['commission.page.scss']
})
export class CommissionPage {
  myTransactions: any;
  viewsTransaction: any[] = [];
  constructor(
    private router: ActivatedRoute
  ) {

    this.router.data.subscribe(

      (data: Data ) => {
        const TRANSACTION = 'transactions';
       // console.log(data);
        if (data[TRANSACTION]){
          this.myTransactions = data[TRANSACTION].compte;

          //console.log(data[TRANSACTION]);
          const trans = data[TRANSACTION].compte;

          trans.transactionDepots.forEach( ts => {
            ts['type'] = 'depot';
          });
          trans.transactionRetraits.forEach( ts => {
            ts['type'] = 'retrait';
          });

          this.viewsTransaction = [...trans.transactionDepots, ...trans.transactionRetraits];
        }
      }
    );
  }

}
