import { User } from './../../model/User';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  baseUrl = `${environment.apiUrl}admin/users`;
  constructor(private http: HttpClient) { }

  getUsers(): Observable<User[]> {
    const URL = `${this.baseUrl}`;
    return this.http.get<User[]>(URL);
  }
  getUser(id): Observable<User> {
    const URL = `${this.baseUrl}/${id}`;
    return this.http.get<User>(URL);
  }
  getCurrentUser(): Observable<User[]> {
    const URL = `${this.baseUrl}/current`;
    return this.http.get<User[]>(URL);
  }
}
