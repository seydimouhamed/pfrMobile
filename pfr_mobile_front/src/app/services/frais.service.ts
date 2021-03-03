import { User } from './../../model/User';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class FraisService {
  baseUrl = `${environment.apiUrl}frais`;
  constructor(private http: HttpClient) { }

  getFrais(montant): Observable<any> {

    const URL = `${this.baseUrl}`;
    return this.http.get<any>(`${URL}?montant[gt]=${montant - 1}`);
  }
  getMonant(montant): Observable<any> {

    const URL = `${this.baseUrl}`;
    return this.http.get<any>(`${URL}?montant[lt]=${montant}&order[montant]=desc`);
  }
  // ?montant[lt]=11000&order[montant]=desc
}
