import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HomePage } from './home.page';
import { PanelComponentModule } from '../panel/panel.module';

import { HomePageRoutingModule } from './home-routing.module';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    RouterModule,
    PanelComponentModule,
    RouterModule.forChild([{ path: '', component: HomePage }]),
    HomePageRoutingModule,
  ],
  declarations: [HomePage]
})
export class HomePageModule {}
