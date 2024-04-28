#include <stdio.h>
#include <stdlib.h>
#include <sys/wait.h>
#include <sys/types.h>
#include <unistd.h>

int AutreProc(char* program,char** arg_list)

{

pid_t child_pid;
child_pid=fork();

if(child_pid!=0)
{
wait(NULL);
pid_t child_pid2;
child_pid2=fork();


if(child_pid2!=0)
{
wait(NULL);
exit(0);
    
}
else
{
printf("********** La Fin du processeus 3 *************\n\n\n\n");
printf("#---------je suis fiss 3 et le processeus 4---------#\n");
printf(" L'identifiant du processus parent est : %d \n ", (int)getppid());
printf(" Mon identifiant est  : %d \n\n ", (int)getpid());
printf("### Moi je crée une repertoire est son lien smbolique.\n");
    system("mkdir Mon_Dossier");
    system("ln -s  Mon_Dossier Mon_Dossier_Nouveau");
printf("**************** c'est fait!!!!!!**************\n\n\n\n");

}
}
else
{
printf("**************** c'est fait!!!!!!**************\n\n\n\n");
printf("#--------je suis fiss 2 et le processeus 3---------#\n");
printf(" L'identifiant du processus parent est : %d \n ", (int)getppid());
printf(" Mon identifiant  est : %d \n\n ", (int)getpid());
printf(" -Voici la liste des processeus actifs : \n\n");
    execvp(program,arg_list);
    fprintf(stderr,"une erreur est survenue au sein de execvp \n"); 
    abort(); 
}


}

int main()
{
   int child_status;
char *arg_list[]={
		  "ps",
	          "-ef", 
		  NULL
		   };
pid_t childs_pid;
childs_pid=fork();
if(childs_pid!=0)
{

printf("#---------je suis le parent et le processeus 1-------#\n");
printf(" Mon Id est : %d \n",(int)getpid());
printf(" #### je fait appelle à mes fiss : \n\n\n\n");
wait(NULL);
AutreProc("ps",arg_list);
wait(NULL);
printf("#___*********** Termine !!!!!!!!!!!!!!!! ********____#\n");


}else
{

sleep(0.1);
printf("#-------- je suis fiss 1  et le processeus 2---------#\n");
printf(" L'identifiant du processus parent est : %d \n ", (int)getppid());
printf(" Mon identifiant est :  %d \n\n ", (int)getpid());
printf("Moi je cherche des fechier modifié durant 24H \n et je le copie dans une repertoire\n ");
char *arg[]={"find","/home/salas/Bureau/SE_exemples","-mtime" ,"-1","-exec", "cp", "-r" ,"{}", "/home/salas/Bureau",";",NULL};
execvp("find",arg);

}


    return 0;
}
