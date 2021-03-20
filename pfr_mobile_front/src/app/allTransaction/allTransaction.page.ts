import { Transaction } from './../../model/Transaction';
import { TransactionService } from './../services/Transaction.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Data } from '@angular/router';

@Component({
  selector: 'app-allTransaction',
  templateUrl: 'allTransaction.page.html',
  styleUrls: ['allTransaction.page.scss']
})
export class AllTransactionPage {
myTransactions: any;
viewsTransaction: any[] = [];
montantAsc = 1;
dateAsc = 1;
nomcompleAsc = 1;

  constructor(
    private transactionService: TransactionService,
    private router: ActivatedRoute) {
      this.router.data.subscribe(
         (data: Data ) => {
            const TRANSACTION = 'transactions';
           // console.log(data);
            if (data[TRANSACTION]){
              this.myTransactions = data[TRANSACTION].compte;

             // console.log(data[TRANSACTION]);
              const trans = data[TRANSACTION].compte;

              trans.transactionDepots.forEach( ts => {
                ts['type'] = 'depot';
                ts['date'] = ts['dateAt'];
                ts['nomComplet'] = ts['depotClient']['nomComplet'];
              });
              trans.transactionRetraits.forEach( ts => {
                ts['type'] = 'retrait';
                ts['date'] = ts['retraitAt'];
                ts['montant'] = ts['montantRetrait'];
                ts['nomComplet'] = ts['retraitClient']['nomComplet'];
              });

              console.log(data);
              this.viewsTransaction = [...trans.transactionDepots, ...trans.transactionRetraits];

              // const fet = this.viewsTransaction.sort((a, b) => {

              //   return a.retraitAt  - b.retraitAt;
              //  });

              // this.sortByDate(true);
              // this.sortByMontant();
             // this.sortByWord(true);
              // const fet1 = this.viewsTransaction.sort((a, b) => {
              //   if (a.retraitAt  < b.retraitAt){return 1; }
              //   if (a.retraitAt  > b.retraitAt){return -1; }
              //   return 0;
              // });

              // console.log(fet1);
            }
          }
      );
    }

    sortByDate(){

      // let pivot = this.dateAsc;
      this.dateAsc = -(this.dateAsc);
      this.viewsTransaction.sort((a, b) => {
        if (a.date  < b.date){return this.dateAsc; }
        if (a.date  > b.date){return -this.dateAsc; }
        return 0;
      });

     // console.log(this.viewsTransaction);
    }


    sortByMontant(asc = false){
      // let pivot = this.montantAsc;
      this.montantAsc = -(this.montantAsc);
      this.viewsTransaction.sort((a, b) => {
        if (a.montant  < b.montant){return this.montantAsc; }
        if (a.montant  > b.montant){return -this.montantAsc; }
        return 0;
      });

      // console.log(this.viewsTransaction);
    }
    sortByWord(asc = false){
      // let pivot = this.nomcompleAsc;
      this.nomcompleAsc = -(this.nomcompleAsc);
      this.viewsTransaction.sort((a, b) => {
        // return a.nomComplet !== b.nomComplet ? a.nomComplet > b.nomComplet ? -1 : 1 : 0;
        if (a.nomComplet  < b.nomComplet){return this.nomcompleAsc; }
        if (a.nomComplet  > b.nomComplet){return -this.nomcompleAsc; }
        return 0;
      });


      console.log(this.viewsTransaction);
    }

}
