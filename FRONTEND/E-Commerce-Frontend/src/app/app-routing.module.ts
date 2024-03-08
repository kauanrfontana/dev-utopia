import { NgModule } from "@angular/core";
import { RouterModule, Routes } from "@angular/router";
import { LoginGuard } from "./auth/components/login/login-guard.service";
import { AuthGuard } from "./shared/guards/auth-guard.service";

const routes: Routes = [
  {
    path: "auth",
    loadChildren: () => import("./auth/auth.module").then((m) => m.AuthModule),
    canActivate: [LoginGuard],
  },
  {
    path: "home",
    loadChildren: () => import("./home/home.module").then((m) => m.HomeModule),
    canActivate: [AuthGuard],
  },
  { path: "", pathMatch: "full", redirectTo: "/auth" },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
