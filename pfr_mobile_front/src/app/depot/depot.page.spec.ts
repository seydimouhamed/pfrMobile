import { ComponentFixture, TestBed, waitForAsync } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';
import { PanelComponentModule } from '../panel/panel.module';

import { DepotPage } from './depot.page';

describe('Tab2Page', () => {
  let component: DepotPage;
  let fixture: ComponentFixture<DepotPage>;

  beforeEach(waitForAsync(() => {
    TestBed.configureTestingModule({
      declarations: [DepotPage],
      imports: [IonicModule.forRoot(), PanelComponentModule]
    }).compileComponents();

    fixture = TestBed.createComponent(DepotPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
