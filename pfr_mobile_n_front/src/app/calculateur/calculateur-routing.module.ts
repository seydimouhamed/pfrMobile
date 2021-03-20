import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CalculateurPage } from './calculateur.page';

const routes: Routes = [
  {
    path: '',
    component: CalculateurPage,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CalculateurPageRoutingModule {}
