import { FormBuilder, Validators } from '@angular/forms';
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
  submitted = false;
  constructor(private authService: AuthenticationService, private fb: FormBuilder, private route: Router) { }

  ngOnInit() {
    this.initForm();
  }

  logForm() {
    this.submitted = true;
    if (this.form.invalid){
      return;
    }
    this.authService.login(this.form.value)
      .subscribe(role => {

        this.submitted = false;
        this.form.reset();
        this.navigate(role);
      },
      er => {
        console.log(er);
      }
      );
  }

  initForm(){
    this.form = this.fb.group({
      username: ['', Validators.required],
      password: ['', Validators.required],
    });
  }

  get f(){
   return this.form.controls;
  }

  navigate(role): void {
      this.route.navigate(['/tabs/home']);
  }
}
