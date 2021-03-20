import { ComponentFixture, TestBed, waitForAsync } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';
import { PanelComponentModule } from '../panel/panel.module';

import { CalculateurPage } from './calculateur.page';

describe('Tab2Page', () => {
  let component: CalculateurPage;
  let fixture: ComponentFixture<CalculateurPage>;

  beforeEach(waitForAsync(() => {
    TestBed.configureTestingModule({
      declarations: [CalculateurPage],
      imports: [IonicModule.forRoot(), PanelComponentModule]
    }).compileComponents();

    fixture = TestBed.createComponent(CalculateurPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
