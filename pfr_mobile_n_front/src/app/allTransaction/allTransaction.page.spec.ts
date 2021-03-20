import { ComponentFixture, TestBed, waitForAsync } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';
import { PanelComponentModule } from '../panel/panel.module';

import { AllTransactionPage } from './allTransaction.page';

describe('Tab2Page', () => {
  let component: AllTransactionPage;
  let fixture: ComponentFixture<AllTransactionPage>;

  beforeEach(waitForAsync(() => {
    TestBed.configureTestingModule({
      declarations: [AllTransactionPage],
      imports: [IonicModule.forRoot(), PanelComponentModule]
    }).compileComponents();

    fixture = TestBed.createComponent(AllTransactionPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
