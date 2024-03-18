import { NgModule } from "@angular/core";
import { ProfileComponent } from "./profile.component";
import { Route, RouterModule } from "@angular/router";
import { SharedModule } from "../shared/shared.module";
import { MatTabsModule } from "@angular/material/tabs";

const Route: Route = {
  path: "",
  component: ProfileComponent,
};

@NgModule({
  declarations: [ProfileComponent],
  imports: [SharedModule, RouterModule.forChild([Route]), MatTabsModule],
})
export class ProfileModule {}
