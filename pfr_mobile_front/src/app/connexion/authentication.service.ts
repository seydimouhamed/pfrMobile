import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Platform } from '@ionic/angular';
import { Storage } from '@ionic/storage';
import { BehaviorSubject, Observable } from 'rxjs';
import { first, map } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { User } from 'src/model/User';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  public currentUserSubject: BehaviorSubject<User>;
  public currentUser: Observable<User>;

  public currentRolesSubject = new BehaviorSubject<boolean>(false);

  tokenInfo: any;

  apiUrl = environment.apiUrl;
  constructor(
    private http: HttpClient,
    private route: Router,
    private storage: Storage,
    private plt: Platform
  ) {
    this.currentUserSubject = new BehaviorSubject<User>(null);
    this.currentUser = this.currentUserSubject.asObservable();
   }
  public get currentUserValue(): User {
    return this.currentUserSubject.value;
  }

  login(username: string, password: string): any{
    return this.http.post<any>(`${this.apiUrl}login`, { username, password })
            .pipe(map(resp => {
              // this.storage.set('name', 'value');
              // console.log(resp.token);
              const decodedToken = JSON.parse(atob(resp.token.split('.')[1]));
              const role = decodedToken.roles[0];
              if (role === 'Role_AdminAgence')
              {
                this.currentRolesSubject.next(true);
              }
              localStorage.setItem('token', resp.token);
              // localStorage.setItem('currentUser', decodedToken);
              // this.storage.set('token', resp);
              // this.storage.set('currentUser', decodedToken);

              this.currentUserSubject.next(resp);
              return decodedToken.roles[0];
            })
    );
  }

  public setCurrentUserValue(user: User): void{
    user.token = this.currentUserValue.token;
    this.currentUserSubject.next(user);
  }
  getUser(): any
  {
    return this.http.get<User>(`${this.apiUrl}admin/user`);
  }


 testStore(){

  this.storage.set('name', 'value');

 }
  getCurrentRole(): Observable<boolean>{
    return this.currentRolesSubject.asObservable();
  }

 getToken(){
// $data='';
  // this.storage.get('token').then( data => {
  //   return data;
  // });
  // let result: string = await this.storage.get('user');

  return localStorage.getItem('token') || null;
 }

 logOut(){
   localStorage.clear();
   this.route.navigate(['/connexion']);
   return;
 }
}
