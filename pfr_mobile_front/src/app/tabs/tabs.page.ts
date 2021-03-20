import { Component } from '@angular/core';
import { ActivatedRoute, Data } from '@angular/router';
import { AuthenticationService } from '../connexion/authentication.service';

@Component({
  selector: 'app-tabs',
  templateUrl: 'tabs.page.html',
  styleUrls: ['tabs.page.scss']
})
export class TabsPage {
isAdmin = false;

  constructor(
    private authService: AuthenticationService,
    private router: ActivatedRoute) {
    this.authService.currentRolesSubject.subscribe( bool =>
      {
       // alert(bool);
        this.isAdmin = bool;
      });
  }


  ngOnInit(): void {
    this.router.data.subscribe(
       (data: Data ) => {
         const CURRENTUSER = 'currentUser';

         const user = data[CURRENTUSER]['hydra:member'][0];
         // console.log(user);
         if (user.profil.libelle === 'AdminAgence'){
             this.authService.currentRolesSubject.next(true);
         }
         else{
          this.authService.currentRolesSubject.next(false);
         }
         this.authService.currentUserSubject.next(user);
       });
  }


  reload(){
    location.reload();
  }

}
