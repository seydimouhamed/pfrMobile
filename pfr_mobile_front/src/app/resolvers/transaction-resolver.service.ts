import { TransactionService } from './../services/Transaction.service';
import {ActivatedRouteSnapshot, Resolve, RouterStateSnapshot} from '@angular/router';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import { Transaction } from 'src/model/Transaction';
const ID = 'id';
@Injectable({
  providedIn: 'root'
})
export class TransactionCUResolverService implements Resolve<Transaction[]> {
  constructor(private transactionService: TransactionService) {}

  resolve(): Observable<Transaction[]> | Promise<Transaction[]> | Transaction[] {
    const data = this.transactionService.getUserTransaction();
    // console.log(data);
    return  data;
  }
}

@Injectable({
  providedIn: 'root'
})
export class TransactionAgenceResolverService implements Resolve<Transaction[]> {
  constructor(private transactionService: TransactionService) {}

  resolve(): Observable<Transaction[]> | Promise<Transaction[]> | Transaction[] {
    const data = this.transactionService.getAgenceTransactions();
    // console.log(data);
    return  data;
  }
}

@Injectable({
  providedIn: 'root'
})
export class CommissionAgenceResolverService implements Resolve<Transaction[]> {
  constructor(private transactionService: TransactionService) {}

  resolve(): Observable<Transaction[]> | Promise<Transaction[]> | Transaction[] {
    const data = this.transactionService.getAgenceCommissions();
    // console.log(data);
    return  data;
  }
}
