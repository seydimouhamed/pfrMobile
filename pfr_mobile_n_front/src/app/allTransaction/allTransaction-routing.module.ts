import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AllTransactionPage } from './allTransaction.page';

const routes: Routes = [
  {
    path: '',
    component: AllTransactionPage,
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AllTransactionPageRoutingModule {}
