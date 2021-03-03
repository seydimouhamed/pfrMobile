import { DynamicModule } from './../components/dynamic.module';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { CommissionPage } from './commission.page';
import { PanelComponentModule } from '../panel/panel.module';

import { CommissionPageRoutingModule } from './commission-routing.module';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    PanelComponentModule,
    DynamicModule,
    CommissionPageRoutingModule
  ],
  declarations: [CommissionPage]
})
export class CommissionPageModule {}
