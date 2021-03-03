import { User } from 'src/model/User';
import { Component } from '@angular/core';
import { AuthenticationService } from '../connexion/authentication.service';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss']
})
export class HomePage {
isAdmin = false;
solde = 0;
date: any;
user: User;
  constructor(private authService: AuthenticationService) {

    this.authService.currentUser.subscribe( user => {
       this.solde = user.agence.compte.solde;
       this.date = user['date'];

       this.user = user;
    });
  }
  deconnexion(){
    this.authService.logOut();
  }
}
