import { DynamicModule } from '../components/dynamic.module';
import { IonicModule } from '@ionic/angular';
import { RouterModule } from '@angular/router';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { CalculateurPage } from './calculateur.page';
import { PanelComponentModule } from '../panel/panel.module';

import { CalculateurPageRoutingModule } from './calculateur-routing.module';

@NgModule({
  imports: [
    IonicModule,
    CommonModule,
    FormsModule,
    PanelComponentModule,
    DynamicModule,
    CalculateurPageRoutingModule
  ],
  declarations: [CalculateurPage]
})
export class CalculateurPageModule {}
