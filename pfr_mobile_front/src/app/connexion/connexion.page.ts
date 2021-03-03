import { FormBuilder } from '@angular/forms';
import { FormGroup } from '@angular/forms';
import { Component, OnInit } from '@angular/core'
import { AuthenticationService } from './authentication.service'
import { Router } from '@angular/router';

@Component({
  selector: 'app-connexion',
  templateUrl: './connexion.page.html',
  styleUrls: ['./connexion.page.scss'],
})
export class ConnexionPage implements OnInit {

  form: FormGroup;
  constructor(private authService: AuthenticationService, private fb: FormBuilder, private route: Router) { }

  ngOnInit() {
  }
  todo = {}
  logForm() {
    this.authService.login('adminagence1', 'passe123')
      .subscribe(role => {
        this.navigate(role);
      },
      er => {
        console.log(er);
      }
      );
    // this.route.navigate(['tabs']);
    // alert( this.authService.testStore());
    console.log(this.todo);
  }

  onSubmit(){
    alert( this.authService.testStore());
  }

  navigate(role): void {
      this.route.navigate(['/tabs/home']);
  }
}
