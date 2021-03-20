import { Transaction } from './../../model/Transaction';
import { TransactionService } from './../services/Transaction.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Data } from '@angular/router';

@Component({
  selector: 'app-transaction',
  templateUrl: 'transaction.page.html',
  styleUrls: ['transaction.page.scss']
})
export class TransactionPage {
myTransactions: any;
viewsTransaction: {}[];
  constructor(
    private transactionService: TransactionService,
    private router: ActivatedRoute) {
      this.router.data.subscribe(
         (data: Data ) => {
           const TRANSACTION = 'transactions';
           // console.log(data);

           if (data[TRANSACTION]){
            this.myTransactions = data[TRANSACTION];
            this.myTransactions['depotAgents'].forEach(trans => {
              trans['type'] = 'depot';
            });
            this.myTransactions['retraitAgents'].forEach(trans => {
              trans['type'] = 'retrait';
            });
            this.viewsTransaction = [...this.myTransactions['depotAgents'], ...this.myTransactions['retraitAgents']];

            console.log(data);

           }

         });
    }


}
