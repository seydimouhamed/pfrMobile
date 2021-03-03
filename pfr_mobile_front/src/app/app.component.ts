import { Component } from '@angular/core';
import { Platform } from '@ionic/angular';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {
  isLog = false;
  public appPages = [
    { title: 'Home', url: '/folder/Inbox', icon: 'home' },
    { title: 'Transactions', url: '/folder/Outbox', icon: 'sync' },
    { title: 'commissions', url: '/folder/Favorites', icon: 'cash' },
    { title: 'Calculateur', url: '/folder/Archived', icon: 'apps' },
    { title: 'Déconnexion', url: '/folder/Spam', icon: 'warning' },
  ];
  constructor(
    private platform: Platform,
   // private alertService: AlertService
  ) {}

}
