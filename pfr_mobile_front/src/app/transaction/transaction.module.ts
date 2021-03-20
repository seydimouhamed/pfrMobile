import { DynamicModule } from './../components/dynamic.module';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { TransactionPage } from './transaction.page';
import { PanelComponentModule } from '../panel/panel.module';

import { TransactionPageRoutingModule } from './transaction-routing.module';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    PanelComponentModule,
    DynamicModule,
    TransactionPageRoutingModule
  ],
  declarations: [TransactionPage]
})
export class TransactionPageModule {}
