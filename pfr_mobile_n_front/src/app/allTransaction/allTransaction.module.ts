import { DynamicModule } from './../components/dynamic.module';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AllTransactionPage } from './allTransaction.page';
import { PanelComponentModule } from '../panel/panel.module';

import { AllTransactionPageRoutingModule } from './allTransaction-routing.module';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    PanelComponentModule,
    DynamicModule,
    AllTransactionPageRoutingModule
  ],
  declarations: [AllTransactionPage]
})
export class AllTransactionPageModule {}
