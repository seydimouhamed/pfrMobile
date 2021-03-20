import { Transaction } from 'src/model/Transaction';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class TransactionService {

  baseUrl = `${environment.apiUrl}user/transactions`;
  constructor(private http: HttpClient){ }

  addTransaction(data): Observable<any>
  {
    return this.http.post<any>(`${this.baseUrl}`, data);
  }
  puTransaction(id, data): Observable<any>
  {
    return this.http.put<any>(`${this.baseUrl}/${id}`, data);
  }


  getTransactionByCode(code): Observable<any>{

    return this.http.get<any>(`${this.baseUrl}?code=${code}`);
  }

  getUserTransaction(): Observable<any>
  {
    const idUser = localStorage.getItem('id');
    return this.http.get<any>(`${environment.apiUrl}users/${idUser}/transactions`);
  }

  getAgenceTransactions(): Observable<Transaction[]>
  {
    const idAgence = localStorage.getItem('idAgence');
    return this.http.get<Transaction[]>(`${environment.apiUrl}agences/${idAgence}/transactions`);
  }

  getAgenceCommissions(): Observable<Transaction[]>
  {
    const idAgence = localStorage.getItem('idAgence');
    console.log(idAgence);


    return this.http.get<Transaction[]>(`${environment.apiUrl}agences/${idAgence}/transactions`);
  }
}
